import React from 'react'
import { Form, Button, Row, Col } from 'react-bootstrap'

export const TodoSearch = () => {
    return (
        <Form className="mt-3">
            <Row>
                <Col>
                    <Form.Control type="text" placeholder="Найти задачу" />
                </Col>
                <Col>
                    <Button variant="primary">Найти</Button>
                </Col>
            </Row>
        </Form>
    )
}