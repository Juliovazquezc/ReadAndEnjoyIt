import Vue from 'vue';

const login = async(data) => {
    const { data: response } = await Vue.axios.post('/auth/login', data);
    return response;
}

export {
    login
}