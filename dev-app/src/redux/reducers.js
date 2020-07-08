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
            const allPosts = state.Posts.filter(post => post.id !== action.payload)

            return {
                ...state,
                Posts: allPosts
            }
        case POST_APP_CREATE:            
            if (action.payload.isLoadingCreate === 2) {
                const allPosts2 = state.Posts
                return {
                    ...state,
                    isLoadingCreate: action.payload.isLoadingCreate,
                    Posts: [{...action.payload.post}].concat(allPosts2)
                }
            } else if (action.payload.isLoadingCreate === 1) {
                return {
                    ...state,
                    isLoadingCreate: action.payload.isLoadingCreate
                }
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