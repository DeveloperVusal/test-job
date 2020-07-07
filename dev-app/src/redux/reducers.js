import {
    POST_APP_ALERT,
    POST_APP_LOAD
} from './types'

const initStatePost = {
    isLoading: false,
    Posts: []
}

export const appPosts = (state = initStatePost, action) => {
    switch (action.type) {
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
    alertMessage: ''
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