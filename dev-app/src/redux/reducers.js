import {
    POST_APP_ALERT,
    POST_APP_LOAD,
    POST_APP_CREATE,
    POST_APP_DELETE
} from './types'

const initStatePost = {
    isLoadingPosts: false,
    isLoadingCreate: 0,
    Posts: []
}

export const appPosts = (state = initStatePost, action) => {
    switch (action.type) {
        case POST_APP_DELETE:
            let allPosts = state.Posts

            if (action.payload.isLoading === 1) {
                allPosts.map(post => {
                    if (post.id === action.payload.idDel) {
                        post.is_loading = 1
                    }

                    return post
                })
            } else if (action.payload.isLoading === 2) {
                allPosts.filter(post => post.id == action.payload.idDel)
            }

            console.log('action.payload.isLoading', action.payload.isLoading)
            console.log('idDel', action.payload.idDel)
            console.log('allPosts', allPosts)

            return {
                ...state,
                Posts: allPosts
            }
        case POST_APP_CREATE:
            const allPosts2 = state.Posts
            console.log('allPosts2', allPosts2)
            console.log('action.payload.post', action.payload.post)

            return {
                ...state,
                Posts: allPosts2.unshift(action.payload.post)
            }
        case POST_APP_LOAD: 
            return {
                ...state,
                ...action.payload
            }
        default:
            return state
    }
}

const initStateAlerts = {
    alert: false,
    type: 'danger',
    message: ''
}

export const appAlerts = (state = initStateAlerts, action) => {
    switch (action.type) {
        case POST_APP_ALERT: 
            return {
                ...state,
                ...action.payload
            }
        default:
            return state
    }
}