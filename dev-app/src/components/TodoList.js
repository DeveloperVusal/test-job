import React, { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'

import { LoadingSpin } from './Loading'
import { actionAppPostsLoad } from '../redux/actions'

const Item = ({ title, text, date}) => {
    return (
        <div className="card mb-3">
            <div className="card-body text-left">
                <h5 className="card-title">{title}</h5>
                <p className="card-text font-weight-normal">{text}</p>
                <p className="card-text font-weight-light">{date}</p>
            </div>
        </div>
    )
}

export const TodoList = () => {
    const dispatch = useDispatch()
    const isLoading = useSelector(state => state.todo_posts.isLoadingPosts)
    const posts = useSelector(state => state.todo_posts.Posts)

    useEffect(() => {
        dispatch(actionAppPostsLoad())
    }, [actionAppPostsLoad, posts])

    if (isLoading) {
        return (
            <div className="d-block mt-5 text-center">
                <div className="text-truncate text-secondary font-weight-bolder">
                    {
                        posts.length
                        ? posts.reverse().map(item => (
                            <Item
                                key={item.id}
                                title={item.title} 
                                text={item.text} 
                                date={item.date}
                            />
                          ))
                        : 'Задач нет'
                    }
                </div>
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