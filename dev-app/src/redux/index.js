import {
    createStore,
    combineReducers,
    compose,
    applyMiddleware
} from 'redux'
import thunk from 'redux-thunk'

import {
    appPosts,
    appAlerts
} from './reducers'

const routeReducers = combineReducers({
    todo_posts: appPosts,
    alert: appAlerts
})

export default createStore(routeReducers, compose(
    applyMiddleware(thunk),
    window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
))