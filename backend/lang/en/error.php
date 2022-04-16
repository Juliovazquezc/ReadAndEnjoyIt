<?php

return [
    'not_found' => 'The resource you are trying to access does not exist',
    'borrowed_book' => 'The book :bookName requested is actually borrowed to :userName user',
    'return_book' => "You cannot return this book because it's available or you are not the last user with the book",
    'database' => "There was an error with the database to complete your action. SQL[:errorCode]", 
    'delete_book' => 'This book cannot be delete because it is borrowed, it can only be deleted if it is available'
];