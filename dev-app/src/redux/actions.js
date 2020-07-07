import { 
    POST_APP_ALERT,
    POST_APP_LOAD
} from './types'

export const actionAppPostsLoad = (obj) => {
    return {
        type: POST_APP_ALERT,
        payload: obj
    }
}

export const actionAppAlert = (obj) => {
    return {
        type: POST_APP_ALERT,
        payload: obj
    }
}