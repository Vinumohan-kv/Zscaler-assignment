import axios from 'axios'

const instance = axios.create({
    baseURL: 'http://local.d948.com',
    headers: {
        'Content-Type': 'application/octet-stream',
        'Accept':'application/vnd.api+json',
    },
});

const endPoint = '';

const api = {
    getApiData: (endPoint) =>
    instance({
        'method':'GET',
        'url': endPoint,
        transformResponse:[function (data){
            const json = JSON.parse(data);
            console.log('in api');
            return json.data? json.data: {};
        }],
    }),
}

export default api