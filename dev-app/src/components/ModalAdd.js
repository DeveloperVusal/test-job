import React from 'react'
import {
    Modal, Form, Button
} from 'react-bootstrap'

export const ModalAdd = ({ isModalToogle, btnToggleModal }) => {
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
                            />
                        </Form.Group>
                        <Form.Group>
                            <Form.Label>Краткое описание</Form.Label>
                            <Form.Control
                                as="textarea" style={{minHeight: '100px', maxHeight: '150px'}}
                            />
                        </Form.Group>
                    </Form>
                </Modal.Body>
                <Modal.Footer className="modal-footer justify-content-center">
                    <Button variant="success">Добавить</Button>
                </Modal.Footer>
            </Modal>
        </>
    )
}