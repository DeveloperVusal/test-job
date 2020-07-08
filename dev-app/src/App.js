import React, { useState } from 'react'

import { TodoHead } from './components/TodoHead'
import { TodoList } from './components/TodoList'
import { ModalAdd } from './components/ModalAdd'

export const App = () => {
    const [isModalAdd, setIsModalAdd] = useState(false)
    const [isSearch, setIsSearch] = useState(false)

    const btnIsModalAddToggle = (val) => {
        setIsModalAdd(val)
    }
    const btnIsSearch = (val) => {
        setIsSearch(val)
    }

    return (
        <div className="container-xl mt-5 mb-5">
            <h2>Todo Application</h2>
            <TodoHead btnToggleModal={btnIsModalAddToggle} btnIsSearch={btnIsSearch} />
            <ModalAdd isModalToogle={isModalAdd} btnToggleModal={btnIsModalAddToggle} />
            <TodoList is_search={isSearch} />
        </div>
    )
}