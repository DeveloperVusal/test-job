import React from 'react'
import { Form, Button } from 'react-bootstrap'
import { useDispatch, useSelector } from 'react-redux'

import { actionAppPostsSearch } from '../redux/actions'

export const TodoHead = ({ btnToggleModal, btnIsSearch }) => {
    const dispatch = useDispatch()

    const btnSearch = (val) => {
        btnIsSearch(true)
        dispatch(actionAppPostsSearch(val))
    }

    const handleSubmit = (event) => {
        event.preventDefault()
        event.stopPropagation()
    }

    return (
        <Form className="d-flex justify-content-between mt-3" onSubmit={handleSubmit}>
            <Form.Control
                className="w-75 mr-5"
                type="search"
                placeholder="Найти задачу"
                onKeyUp={(event) => {    
                    if (event.keyCode === 13) {
                        btnSearch(event.target.value)
                    }

                    if (!event.target.value.length > 0) btnIsSearch(false)
                }}
                onChange={(event) => {
                    if (!event.target.value.length > 0) btnIsSearch(false)
                }}
            />
            <Button
                className="flex-shrink-1"
                variant="dark"
                onClick={() => {
                    btnToggleModal(true)
                }}
            >
                Добавить задачу
            </Button>
        </Form>
    )
}