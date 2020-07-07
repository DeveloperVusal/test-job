import React from 'react'
import { useSelector } from 'react-redux'

import { LoadingSpin } from './Loading'

export const TodoList = () => {
    const isLoading = useSelector(state => state.load_posts.isLoading)

    if (isLoading) {
        return (
            <div className="d-block mt-3 text-center">
                <div className="text-truncate text-secondary font-weight-bolder">Задач нет</div>
            </div>
        )
    } else {
        return (
            <div className="d-block mt-3 text-center">
                <LoadingSpin />
            </div>
        )
    }
}