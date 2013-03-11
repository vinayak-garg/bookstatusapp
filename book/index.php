<?php

require('dbconfig.php');

require('Slim/Slim.php');
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/', 'viewAll');
$app->post('/', 'addBook');
$app->put('/:id', 'editBook');
$app->delete('/:id', 'deleteBook');

$app->run();

function test()
{
    echo 'Hello';
}

function viewAll()
{
    $bookname = \Slim\Slim::getInstance()->request()->get('bookname');
    if ($bookname)
    {
        $sql = "SELECT * FROM books WHERE bookname = '$bookname' ORDER BY id";
    }
    else
    {
        $sql = "SELECT * FROM books ORDER BY id";
    }

    $result = mysql_query($sql);
    if ($result)
    {
        $rows = array();
        while ($row = mysql_fetch_assoc($result))
        {
            $rows[] = $row;
        }
        echo json_encode($rows);
        exit();
    }
    echo json_encode(array('error' => true, 'msg' => 'Unable to retrieve values'));
}

function addBook()
{
    $request = \Slim\Slim::getInstance()->request();
    $book = json_decode($request->getBody());

    //$id = $book->id;
    $bookname = $book->bookname;
    $authorname = $book->authorname;
    $bookstatus = $book->bookstatus;

    $error = true;

    if ($bookname == '')
    {
        $msg = 'Book name missing.'.$bookname;
    }
    else if ($authorname == '')
    {
        $msg = 'Author name missing';
    }
    else if ($bookstatus == '')
    {
        $msg = 'How???';
    }
    else
    {
        $error = false;
        $msg = 'Success';
    }

    if (!$error)
    {
        $sql = "INSERT INTO books(bookname, authorname, bookstatus) VALUES('$bookname', '$authorname', '$bookstatus')";
        $result = mysql_query($sql);
        if ($result)
        {
            echo json_encode(array('error' => false, 'msg' => 'Saved successfully'));
            exit();
        }
        else
        {
            $msg = 'Unable to save';
        }
    }

    echo json_encode(array('error' => true, 'msg' => $msg));
}

function editBook($id)
{
    $request = \Slim\Slim::getInstance()->request();
    $book = json_decode($request->getBody());

    $id = $book->id;
    $bookname = $book->bookname;
    $authorname = $book->authorname;
    $bookstatus = $book->bookstatus;

    $error = true;

    if ($bookname == '')
    {
        $msg = 'Book name missing.'.$bookname;
    }
    else if ($authorname == '')
    {
        $msg = 'Author name missing';
    }
    else if ($bookstatus == '')
    {
        $msg = 'How???';
    }
    else
    {
        $error = false;
        $msg = 'Success';
    }

    if (!$error)
    {
        $sql = "UPDATE books SET bookname='$bookname', authorname='$authorname', bookstatus='$bookstatus' WHERE id = '$id'";
        $result = mysql_query($sql);
        if ($result)
        {
            echo json_encode(array('error' => false, 'msg' => 'Saved successfully'));
            exit();
        }
        else
        {
            $msg = 'Unable to save';
        }
    }

    echo json_encode(array('error' => true, 'msg' => $msg));
}

function deleteBook($id)
{
    $sql = "DELETE FROM books WHERE id='$id'";

    $result = mysql_query($sql);
    if (!$result)
    {
        exit(1);
        //echo json_encode(array('error' => true, 'msg' => 'Unable to Delete'));
    }
    echo json_encode(array());
}
?>
