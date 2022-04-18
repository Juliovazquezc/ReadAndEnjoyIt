import axios from 'axios';

const getAllBooks = async (limit = 10, page) => {
    const { data: response } = await axios.get(`/books?limit=${limit}&page=${page}`);
    return response
}

export {
    getAllBooks
}