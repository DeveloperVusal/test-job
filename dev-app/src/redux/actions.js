import { useSelector } from 'react-redux'

import {
    POST_APP_ALERT,
    POST_APP_LOAD,
    POST_APP_CREATE,
    POST_APP_DELETE
} from './types'

export const actionAppPostDel = id => {
    return async dispatch => {
        dispatch({
            type: POST_APP_DELETE,
            payload: {
                idDel: id,
                isLoading: 1
            }
        })

        const response = await fetch('/api/post_delete', {
            method: 'POST',
            body: JSON.stringify({
                csrf: document.getElementById('token_csrf').value,
                post_id: id
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        
        const json = await response.json()

        if (json.type === 'success') {
            dispatch({
                type: POST_APP_DELETE,
                payload: {
                    idDel: id,
                    isLoading: 2
                }
            })
        } else {
            dispatch({
                type: POST_APP_ALERT,
                payload: {
                    alert: true,
                    type: json.type === 'error'?'danger':'warning',
                    message: json.message
                }
            })

            dispatch({
                type: POST_APP_DELETE,
                payload: {
                    idDel: id,
                    isLoading: null
                }
            })
        }
    }
}

export const actionAppPostCreate = (obj) => {
    return async dispatch => {
        dispatch({
            type: POST_APP_CREATE,
            payload: {
                isLoadingCreate: 1
            }
        })

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
                    type: json.type === 'error'?'danger':'warning',
                    message: json.message
                }
            })
        }

        if (json.type === 'success') {
            dispatch({
                type: POST_APP_CREATE,
                payload: {
                    isLoadingCreate: 2,
                    post: json.response
                }
            })
        } else {
            dispatch({
                type: POST_APP_CREATE,
                payload: {
                    isLoadingCreate: null
                }
            })
        }
    }
}

export const actionAppPostsLoad = () => {
    return async dispatch => {
        const response = await fetch('/api/get_posts', {
            method: 'POST',
            body: JSON.stringify({
                csrf: document.getElementById('token_csrf').value
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        
        const json = await response.json()

        if (json.type === 'success') {
            const allPosts = []
            
            json.response.map(item => {
                allPosts.push({
                    ...item,
                    is_loading: null
                })
            })

            console.log('newPosts', allPosts)

            dispatch({
                type: POST_APP_LOAD,
                payload: {
                    isLoadingPosts: true,
                    Posts: allPosts
                }
            })
        }
    }
}

export const actionAppAlert = (obj) => {
    return {
        type: POST_APP_ALERT,
        payload: obj
    }
}