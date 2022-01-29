import axios from "./api";
import {Modal,Form} from "react-bootstrap";
import React from "react";

function ModalShow(props) {
    const reply = () => {
        axios.post('/store', props.state)
            .then(response => {
                    if (response.success === true) {
                        axios.get('/roots')
                            .then(response => {
                                    if (response.success === true) {
                                        props.setData(response.data);
                                        props.onHide(false)
                                        props.setState({})
                                    }

                                }
                            ).catch(function (error) {
                                console.log(error.data.message);
                            }
                        )
                    }

                }
            ).catch(function (error) {
                console.log(error.data.message);
            }
        )

    };
    return (
        <Modal
            {...props}
            size="lg"
            aria-labelledby="contained-modal-title-vcenter"
            centered
        >
            <Modal.Header closeButton>
                <Modal.Title id="contained-modal-title-vcenter">
                    post reply
                </Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <div className="">
                    <div className="d-flex flex-column align-items-start">
                        {props.labels.map((item, key) => {
                            return (
                                <Form.Group className="mt-3 w-100" controlId="formBasicEmail">
                                    <Form.Label>{item.label}</Form.Label>
                                    <Form.Control
                                        as={item.as}
                                        onChange={props.onChange}
                                        type={item.type}
                                        placeholder={item.placeholder}
                                        name={item.name}
                                    />
                                </Form.Group>
                            )
                        })
                        }
                    </div>
                    <div className="mt-2 text-right mt-3">

                    </div>
                </div>
            </Modal.Body>
            <Modal.Footer>
                <button className="btn btn-primary btn-sm shadow-none" type="button" onClick={reply}>
                    Post reply
                </button>
                <button className="btn btn-danger btn-sm shadow-none" onClick={() => props.onHide(false)}>
                    Close
                </button>
            </Modal.Footer>
        </Modal>
    )
}export default ModalShow
