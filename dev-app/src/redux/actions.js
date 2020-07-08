import { 
    POST_APP_ALERT,
    POST_APP_LOAD,
    POST_APP_CREATE
} from './types'

export const actionAppPostCreate = (obj) => {
    return async dispatch => {
        dispatch({
            type: POST_APP_CREATE,
            payload: {
                isLoadingCreate: 1
            }
        })

        console.log('Send obj', JSON.stringify({
            csrf: document.getElementById('token_csrf').value,
            title: obj.title,
            text: obj.text
        }))

        const response = await fetch('/api/post_add', {
            method: 'POST',
            body: JSON.stringify({
                csrf: document.getElementById('token_csrf').value,
                title: obj.title,
                text: obj.text
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        
        const json = await response.json()

        console.log('json result response', json)

        if (json.type !== 'success') {
            dispatch({
                type: POST_APP_ALERT,
                payload: {
                    alert: true,
                    type: json.type,
                    message: json.message
                }
            })
        }

        dispatch({
            type: POST_APP_CREATE,
            payload: {
                isLoadingCreate: 2
            }
        })
    }
}

export const actionAppPostsLoad = () => {
    return async dispatch => {
        const response = await fetch('/api/get_posts', {
            method: 'POST',
            headers: {
                'Content-Type': 'text/html' //'application/json'
            }
        })
        
        const result = (await response.text()).toString()

        console.log('Loading Posts', result)

        dispatch({
            type: POST_APP_LOAD,
            payload: {
                isLoadingPosts: true
            }
        })
    }
}

export const actionAppAlert = (obj) => {
    return {
        type: POST_APP_ALERT,
        payload: obj
    }
}