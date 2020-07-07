import { 
    POST_APP_ALERT,
    POST_APP_LOAD
} from './types'

export const actionAppPostsLoad = () => {
    return async dispatch => {
        const response = await fetch('/api/get_posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'text/html' //'application/json'
            }
        })
        
        const result = (await response.text()).toString()

        console.log('load result', result)

        dispatch({
            type: POST_APP_LOAD,
            payload: {
                isLoading: true
            }
        })
    } 

    /*{
        type: POST_APP_LOAD,
        payload: obj
    }*/
}

export const actionAppAlert = (obj) => {
    return {
        type: POST_APP_ALERT,
        payload: obj
    }
}