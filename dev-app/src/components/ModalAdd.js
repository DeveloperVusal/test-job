import React, { useState, useEffect, useCallback } from 'react'
import {
    Modal, Form, Button, Alert
} from 'react-bootstrap'
import { useDispatch, useSelector } from 'react-redux'

import { actionAppPostCreate, actionAppAlert } from '../redux/actions'
import { LoadingSpin } from './Loading'

export const ModalAdd = ({ isModalToogle, btnToggleModal }) => {
    const isLoading = useSelector(state => state.todo_posts.isLoadingCreate)
    const isAlert = useSelector(state => state.alert.alert)
    const isAlertType = useSelector(state => state.alert.type)
    const isAlertMessage = useSelector(state => state.alert.message)

    const [valTitle, setValTitle] = useState('')
    const [valText, setValText] = useState('')

    const dispatch = useDispatch()

    const btnCreatePost = useCallback(() => {
        if (valTitle !== '' && valText !== '') {
            dispatch(actionAppAlert({
                alert: false,
                message: ''
            }))

            dispatch(actionAppPostCreate({
                title: valTitle,
                text: valText
            }))
        } else {
            dispatch(actionAppAlert({
                alert: true,
                message: 'Заполните все поля'
            }))
        }
    })

    useEffect(() => {
        console.log('isLoading', isLoading)

        if (isLoading === 2) {
            setValTitle('')
            setValText('')
    
            setTimeout(() => {
                btnToggleModal(false)
            }, 1000)
        }

    }, [isLoading])

    return (
        <>
            <Modal
                show={isModalToogle}
                onHide={() => btnToggleModal(false)}
                backdrop="static"
                keyboard={false}
                centered={true}
            >
                <Modal.Header closeButton>
                <Modal.Title>Добавление задачи</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Form>
                        <Form.Group>
                            <Form.Label>Название задачи</Form.Label>
                            <Form.Control
                                type="text"
                                onChange={(event) => {
                                    setValTitle(event.target.value)
                                }}
                            />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Краткое описание</Form.Label>
                            <Form.Control
                                as="textarea" style={{minHeight: '100px', maxHeight: '150px'}}
                                onChange={(event) => {
                                    setValText(event.target.value)
                                }}
                            />
                        </Form.Group>
                        <Alert show={isAlert} key="1" variant={isAlertType}>
                            {isAlertMessage}
                        </Alert>
                    </Form>
                </Modal.Body>
                <Modal.Footer className="modal-footer justify-content-center">
                    <Button 
                        variant="success"
                        onClick={() => {
                            btnCreatePost()
                        }}
                    >
                        Добавить
                    </Button>
                    {isLoading === 1 && <LoadingSpin />}
                </Modal.Footer>
            </Modal>
        </>
    )
}