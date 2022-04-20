import axios from 'axios';

const getAllCategories = async () => {
    const { data:response } = await axios.get('/categories');
    return response;
}

export {
    getAllCategories
} 