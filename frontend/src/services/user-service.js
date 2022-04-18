import axios from 'axios';

const getUser = async () => {
    const {data: response} = await axios.get('/users/me');
    return response;
}

export {
    getUser
}