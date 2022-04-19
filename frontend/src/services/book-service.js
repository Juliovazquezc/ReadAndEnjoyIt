import axios from 'axios';

const getAllBooks = async (limit = 10, page) => {
    const { data: response } = await axios.get(`/books?limit=${limit}&page=${page}`);
    return response
}

const deleteBook = async (id) => {
    const {data: response} = await axios.delete(`/books/${id}`);
    return response
}

export {
    getAllBooks,
    deleteBook
}