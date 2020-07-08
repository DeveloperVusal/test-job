import React, { useEffect, useCallback } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { Button, Alert } from 'react-bootstrap'

import { LoadingSpin } from './Loading'
import { actionAppPostsLoad, actionAppPostDel } from '../redux/actions'

const Item = ({ id, title, text, date, btnDel, is_loading}) => {
    return (
        <div className="d-flex mb-3 border rounded-sm">
            <div className="w-100">
                <div className="card-body text-left">
                    <h5 className="card-title">{title}</h5>
                    <p className="card-text font-weight-normal">{text}</p>
                    <p className="card-text font-weight-light">{date}</p>
                </div>
            </div>
            <div className="flex-shrink-1 justify-content-center align-items-center">
                <Button variant="danger" onClick={() => btnDel(id)}>Удалить</Button>
            </div>
        </div>
    )
}

export const TodoList = ({is_search}) => {
    const dispatch = useDispatch()
    const isLoading = is_search ? useSelector(state => state.todo_posts.isLoadingSearchs) : useSelector(state => state.todo_posts.isLoadingPosts)
    const posts = is_search ? useSelector(state => state.todo_posts.Searchs) : useSelector(state => state.todo_posts.Posts)

    const btnDelPost = useCallback((val) => {
        dispatch(actionAppPostDel(val))
    }, [actionAppPostDel])


    useEffect(() => {
        dispatch(actionAppPostsLoad())
    }, [])

    if (isLoading) {
        return (
        <>
            <div className="d-block mt-5 text-center">
                <div className="text-truncate text-secondary font-weight-bolder">
                    {
                        posts.length
                        ? posts.map(item => (
                            <Item
                                key={item.id}
                                id={item.id}
                                title={item.title} 
                                text={item.text} 
                                date={item.date}
                                btnDel={btnDelPost}
                            />
                          ))
                        : 'Задач нет'
                    }
                </div>
            </div>
        </>
        )
    } else {
        return (
            <div className="d-block mt-3 text-center">
                <LoadingSpin />
            </div>
        )
    }
}