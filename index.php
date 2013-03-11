<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Book Status App</title>
        <script type="text/javascript" src="js/jquery-min.js"></script>
        <script type="text/javascript" src="js/underscore-min.js"></script>
        <script type="text/javascript" src="js/backbone-min.js"></script>
        <style type="text/css">
            #buttons a {text-decoration:none};
        </style>
    </head>
    <body>
        <div id="buttons">
            <a href=""><input type="button" value="Home"/></a>
            <a href="#viewall"><input type="button" value="View All"/></a>
            <a href="#add"><input type="button" value="Add Book"/></a>
            <a href="#search"><input type="button" value="Search"/></a>
        </div>
        <div id="content">
        </div>
        <!-- Templates -->
        <!-- View All Template -->
        <script type="text/template" id="viewallTemplate">
            <h2>View All Books</h2>
            <table width="720px" border="1" cellspacing="0" cellpadding="4">
                <tr>
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Book Status</th>
                    <th>Edit</th>
                </tr>
                <% if ($.isEmptyObject(books)){ %>
                    <tr>
                        <td colspan="4">Add Some Books!</td>
                    </tr>
                <% }else{
                    $.each(books, function(){ %>
                        <tr>
                            <td><%= this.bookname %></td>
                            <td><%= this.authorname %></td>
                            <td><%= this.bookstatus %></td>
                            <td><a href="#edit/<%= this.id %>">Edit</a></td>
                        </tr>
                    <% })
                } %>
            </table>
        </script>
        <!-- Add Book Template -->
        <script type="text/template" id="addTemplate">
            <h2><%= action %> Book</h2>
            <form id="addbookform">
            <table width="500px">
                <tr>
                    <td>Book Name</td>
                    <td><input type="text" id="bookname" value="<%= bookname %>"></td>
                </tr>
                <tr>
                    <td>Author Name</td>
                    <td><input type="text" id="authorname" value="<%= authorname %>"></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select id="bookstatus">
                            <option value="Read" <% if (bookstatus == 'Read'){ %> selected <% } %>   >Read</option>
                            <option value="Not yet read" <% if (bookstatus == 'Not yet read'){ %> selected <% } %>>Not yet read</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="id" value="<%= id %>">
            <p>
            <% if (action == "Edit"){ %>
                <span id="buttons">
                    <a href="#delete/<%= id %>"><input type="button" value="Delete" style="color:red"></a>
                </span>&nbsp;
            <% } %>
            <input type="submit" value="<%= action %> Book"/>
            </p>
            </form>
            <p id="error" style="color:red"></p>
            <p id="success" style="color:green"></p>
        </script>
        <!-- Search Book Template -->
        <script type="text/template" id="searchTemplate">
            <h2>Search Books</h2>
            <form id="searchBookForm">
                <p>Enter book name : <input type="text" id="searchbookname"></p>
                <input type="submit" value="search">
            </form>
            <% if (books !== null && $.isEmptyObject(books)){ %>
                <p>Found no book named <b>"<%= querystring %>"</b></p>
            <% }else if (!($.isEmptyObject(books))){ %>
            <h3>Search Results for "<%= querystring %>"</h3>
            <table width="720px" border="1" cellspacing="0" cellpadding="4">
                <tr>
                    <th>Book Name</th>
                    <th>Author Name</th>
                    <th>Book Status</th>
                    <th>Edit</th>
                </tr>
                <% $.each(books, function(){ %>
                    <tr>
                        <td><%= this.bookname %></td>
                        <td><%= this.authorname %></td>
                        <td><%= this.bookstatus %></td>
                        <td><a href="#edit/<%= this.id %>">Edit</a></td>
                    </tr>
                <% });
                } %>
            </table>
        </script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>
