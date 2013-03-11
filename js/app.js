var Book = Backbone.Model.extend({
    defaults: {
        id: null,
        bookname:   'Default Name',
        authorname: 'Default Author',
        bookstatus: 'Not yet read',
    },
    urlRoot: "book/"
});

var BooksCollection = Backbone.Collection.extend({
    model: Book,
    url: "book/"
});

var ViewallView = Backbone.View.extend({
    el: 'div#content',
    template: _.template($('#viewallTemplate').html()),
    render: function(e){
        $(this.el).html(this.template({books: e}));
    }
});

var AddView = Backbone.View.extend({
    el: 'div#content',
    template: _.template($('#addTemplate').html()),
    events: {
        'submit #addbookform': 'addBookEvent'
    },
    render: function(e){
        var id = e.get('id');
        $(this.el).html(this.template({
            action: (id != null ? 'Edit':'Add'),
            id: id,
            bookname: e.get('bookname'),
            authorname: e.get('authorname'),
            bookstatus: e.get('bookstatus')
        }));
    },
    addBookEvent: function(event){
        var id = $('#id').val(),
            bookname = $('#bookname').val(),
            authorname = $('#authorname').val(),
            bookstatus = $('#bookstatus').val(),
            book;
        if (id === ''){
            book = new Book({
                bookname: bookname,
                authorname: authorname,
                bookstatus: bookstatus
            });
        }else{
            book = new Book({
                id: id,
                bookname: bookname,
                authorname: authorname,
                bookstatus: bookstatus
            });
        }
        book.save({}, {
            success: function(model, response){
                if (response.error){
                    $('#error').html(response.msg);
                    $('#success').html('');
                }else{
                    $('#success').html(response.msg);
                    $('#error').html('');
                }
            },
            error: function(){
                $('#error').html('Unable to save');
                $('#success').html('');
            },
        });
        return false;   //Prevent submission
    }
});

var SearchView = Backbone.View.extend({
    el: 'div#content',
    template: _.template($('#searchTemplate').html()),
    events: {
        'submit #searchBookForm': 'searchBookEvent'
    },
    render: function(e, qs){
        $(this.el).html(this.template({
            books: e,
            querystring: qs
        }));
    },
    searchBookEvent: function(event){
        var self = this;
        var matchedBooks = new BooksCollection();
        var querystring = $('#searchbookname').val();
        matchedBooks.fetch({
            data: {bookname: querystring},
            success: function(collection, response){
                self.render(response, querystring);
            }
        });
    }
});

var AppRouter = Backbone.Router.extend({
    routes:{
        "": "viewall",
        "viewall": "viewall",
        "add": "add",
        "edit/:id": "edit",
        "delete/:id": "_delete",
        "search": "search"
    },

    viewall: function(){
        this.viewallView = new ViewallView();
        var self = this;
        window.booksCollection.fetch({
            success: function(collection, response){
                self.viewallView.render(response);
            }
        });
    },

    add: function(){
        this.book = new Book();
        this.addView = new AddView();
        this.addView.render(this.book);
    },

    edit: function(id){
        this.addView = new AddView();
        var book = window.booksCollection.get(id);
        this.addView.render(book);
    },

    _delete: function(id){
        if (confirm("Are you sure you want to delete?")){
            var book = window.booksCollection.get(id);
            book.destroy({
                success: function(){
                    window.location.assign("");
                }
            });
        }
    },

    search: function(){
        this.searchView = new SearchView();
        this.searchView.render(null);
    }
});

$(function(){
    window.booksCollection = new BooksCollection();
    window.booksCollection.fetch();
    var app = new AppRouter();
    Backbone.history.start();
});
