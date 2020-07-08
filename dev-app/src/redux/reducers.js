import {
    POST_APP_ALERT,
    POST_APP_LOAD,
    POST_APP_CREATE
} from './types'

const initStatePost = {
    isLoadingPosts: false,
    isLoadingCreate: 0,
    Posts: []
}

export const appPosts = (state = initStatePost, action) => {
    switch (action.type) {
        case POST_APP_CREATE: 
            return {
                ...state,
                ...action.payload
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