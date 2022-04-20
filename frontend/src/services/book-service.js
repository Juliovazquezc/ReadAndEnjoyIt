import axios from 'axios';

const getAllBooks = async (limit = 10, page) => {
    const { data: response } = await axios.get(`/books?limit=${limit}&page=${page}`);
    return response
}

const deleteBook = async (id) => {
    const {data: response} = await axios.delete(`/books/${id}`);
    return response
}

const createBook = async (data) => {
    const {data: response} = await axios.post('/books', data);
    return response;
}

const editBook = async (id, data) => {
    const {data: response } = await axios.put(`/books/${id}`, data);
    return response;
}

const borrowBook = async (id) => {
    const {data: response } = await axios.put(`/books/${id}/borrow`);
    return response;
}

const returnBook = async (id) => {
    const {data: response} = await axios.put(`/books/${id}/return`);
    return response;
}

export {
    getAllBooks,
    deleteBook,
    createBook,
    editBook,
    borrowBook,
    returnBook,
}