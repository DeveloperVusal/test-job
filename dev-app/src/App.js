import React from 'react'

import { TodoSearch } from './components/TodoSearch'
import { TodoList } from './components/TodoList'

export const App = () => {
    return (
        <div className="container-xl mt-5">
            <h2>Todo Application</h2>
            <TodoSearch />
            <TodoList />
        </div>
    )
}