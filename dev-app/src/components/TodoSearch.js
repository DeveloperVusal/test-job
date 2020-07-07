import React from 'react'
import { Form, Button, Row, Col } from 'react-bootstrap'

export const TodoSearch = () => {
    return (
        <Form className="d-flex justify-content-between mt-3">
            <Form.Control className="w-100 mr-5" type="text" placeholder="Найти задачу" />
            <Button className="flex-shrink-1" variant="primary">Найти</Button>
        </Form>
    )
}