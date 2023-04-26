import axios from "axios";
axios.defaults.baseURL="/api";
const token=sessionStorage.getItem('token');
axios.defaults.headers.common['Authorization']=`Bearer ${token}`;
// const axiosClient = axios.create({
//     baseURL: '/api',
//     headers: "Authorization: Bearer "
// });