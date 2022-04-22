import axios from 'axios';

const login = async(data) => {
    const { data: response } = await axios.post('/auth/login', data);
    return response;
}

const register = async (data) => {
    const {data: response} = await axios.post('/auth/register', data);
    return response;
}

export {
    login,
    register
}