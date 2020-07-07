import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { LoadingSpin } from './Loading'
import { actionAppPostsLoad } from '../redux/actions'

export const TodoList = () => {
    const dispatch = useDispatch()
    const isLoading = useSelector(state => state.load_posts.isLoading)

    useEffect(() => {
        dispatch(actionAppPostsLoad())
    }, [actionAppPostsLoad])

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