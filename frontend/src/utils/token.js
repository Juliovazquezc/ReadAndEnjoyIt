import axios from 'axios';

const setTokenAxios = () => {
    let objectToken = localStorage.getItem('token');
    if (objectToken) {
        objectToken = JSON.parse(objectToken); 
        const formatedToken = `${objectToken.token_type} ${objectToken.access_token}`;
        axios.defaults.headers.common['Authorization'] = formatedToken
    }
} 
export {
    setTokenAxios
}




