import React from 'react'
import { Form, Button, Row, Col } from 'react-bootstrap'

export const TodoHead = ({ btnToggleModal }) => {
    return (
        <Form className="d-flex justify-content-between mt-3">
            <Form.Control className="w-75 mr-5" type="text" placeholder="Найти задачу" />
            <Button className="flex-shrink-1" variant="primary">Найти</Button>
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