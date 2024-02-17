import axios from 'axios'

axios.interceptors.response.use((res) => {
    return res
}, (error) => {
    if (error.response.status === 401) {
        localStorage.removeItem('token')

        if (window.location.pathname !== '/welcome') {
            window.location.replace('/welcome')
            window.location.reload()
        }
    }
})

export const makeRequest = axios
