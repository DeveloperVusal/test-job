import React from 'react'
import ReactDOM from 'react-dom'
import { Provider } from 'react-redux'
import './index.scss'

import { App } from './App'
import Store from './redux'

ReactDOM.render(
    <Provider store={Store}>
        <App />
    </Provider>,
    document.getElementById('root')
)