import React, {useEffect, useState} from 'react'
import '../Assets/css/main.css'
import aloware from '../Assets/images/aloware.png'
import blogImage from '../Assets/images/Aloware-inbound-call-center.png'
import {MdDateRange} from 'react-icons/md'
import {FaUserAlt, FaReply, FaCommentDots} from 'react-icons/fa'
import {Badge, Button, Form} from 'react-bootstrap';
import axios from './../component/api'
import history from './../component/history'
import Modal from './../component/Modal'

function ShowReply(props) {
    return (
        <>
            {
                props.item.children.map((child, key) => {
                    console.log('children', child)
                    return (
                        <Reply
                            children={child}
                            onHide={props.onHide}
                            setState={props.setState}
                        />
                    )
                })
            }
        </>
    )
}

function Reply(props) {
    return (
        <>
            <div className=" ml-5 col-md-10 mb-3">
                <div className=" d-flex ml-5 flex-column comment-section">
                    <div className="background-comment p-2">
                        <div className="d-flex flex-row user-info">
                            <div
                                className="d-flex flex-column justify-content-start ml-2">
                <span className="d-block font-weight-bold name">
                {props.children.name}
                </span>
                            </div>
                        </div>
                        <div className="mt-2">
                            <p className="comment-text">
                                {props.children.text}
                            </p>
                        </div>
                    </div>
                    <div className="bg-white">
                        <div className="d-flex flex-row fs-12">
                            <div className="like p-2 cursor">
                                {
                                    props.children.depth === 2 ? null : <span onClick={() => {
                                        props.onHide(true);
                                        props.setState(
                                            {
                                                parent_id: props.children.id
                                            })
                                    }}>
                                                             <FaReply/>
                                                              <span className=" ml-2 position-relative">
                                                                add reply
                                                              </span>
                                                        </span>
                                }

                            </div>
                        </div>
                    </div>
                </div>
                <ShowReply item={props.children}
                           onHide={props.onHide}
                           setState={props.setState}/>
            </div>

        </>

    )
}

function Blog() {
    const [Data, setData] = useState([]);
    const [state, setState] = useState({});
    const [modalShow, setModalShow] = useState(false);
    useEffect(() => {
            axios.get('/roots')
                .then(response => {
                        if (response.success === true) {
                            setData(response.data);
                        }

                    }
                ).catch(function (error) {
                    console.log(error.data.message);
                }
            )
        }, []
    );
    const onChange = (e) => {
        e.preventDefault()
        const {name, value, type, files} = e.target;
        const newVal = type === "file" ? files[0] : value;
        setState({
            ...state,
            [name]: newVal
        });
    };
    const labels = [
        {
            label: 'name',
            type: 'text',
            placeholder: 'write your name...',
            name: 'name',
        },
        {
            label: 'comment',
            type: 'text',
            placeholder: 'write your comment...',
            as: 'textarea',
            name: 'text',
        },

    ];

    const create = () => {
        axios.post('/store', state)
            .then(response => {
                    if (response.success === true) {
                        axios.get('/roots')
                            .then(response => {
                                    if (response.success === true) {
                                        setData(response.data);
                                        setState(null)
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
        <body>
        <div className="header">
            <img src={aloware} alt="aloware" className="w-50"/>
        </div>

        <div className="row">
            <div className="leftcolumn">
                <div className="card">
                    <h2>7 ways Aloware helps companies manage inbound call center operations</h2>
                    <div className="d-flex w-100 justify-content-around">
                        <div className="d-flex align-items-center">
                            <MdDateRange className="text-muted"/>
                            <span className="text-muted">January 17, 2022</span>
                        </div>

                        <div className="d-flex align-items-center">
                            <FaUserAlt className="text-muted"/>
                            <span className="text-muted">Nikho Arrosas</span>
                        </div>

                    </div>

                    <div className="fakeimg">
                        <img src={blogImage} alt="aloware" className="w-100"/>
                    </div>
                    <p className="p-2 fw-bold">
                        Managing inbound call center operations is no easy task, but with the right tools and systems in
                        place, you will be able to handle incoming calls from customers seamlessly.
                        Having your own inbound call center does offer a lot of benefits. You will have a huge advantage
                        when you have call center agents speaking directly to customers, especially when you are
                        launching a new product or promoting special offers. Satisfied customers are more likely to
                        re-purchase and possibly become brand advocates in the future. By delivering top-notch support,
                        an inbound call center can help you maintain a loyal customer base.
                        However, there are a lot of factors that can hinder call centers from running in peak
                        performance. Let us take a look at common problems that companies face when it comes to managing
                        their inbound call center operations.
                    </p>
                </div>
            </div>
        </div>
        <h1 className="mt-3">comments</h1>
        <div className="bg-light mt-3 p-2">
            <div className="d-flex flex-column align-items-start">
                {labels.map((item, key) => {
                    return (
                        <Form.Group className="mt-3 w-100" controlId="formBasicEmail">
                            <Form.Label>{item.label}</Form.Label>
                            <Form.Control
                                as={item.as}
                                onChange={onChange}
                                type={item.type}
                                placeholder={item.placeholder}
                                name={item.name}
                            />
                        </Form.Group>
                    )
                })
                }
            </div>
            <div className="mt-2 text-right ">
                <button className="btn btn-primary btn-sm shadow-none" type="button" onClick={create}>
                    Post comment
                </button>
            </div>
        </div>
        <div className="footer">
            <div className="w-75 p-0 ">
                <div className="d-flex row">
                    {
                        Data.map((item, key) => {
                            console.log('item', item);
                            return (
                                <div className="col-md-8 mt-3 border-2 border-comment">
                                    <div className="d-flex flex-column comment-section">
                                        <div className="bg-white  p-2">
                                            <div className="d-flex flex-row user-info">
                                                <div className="d-flex flex-column justify-content-start ml-2">
                                        <span className="d-block font-weight-bold name">
                                            {item.name}
                                         </span>
                                                </div>
                                            </div>
                                            <div className="mt-2">
                                                <p className="comment-text">
                                                    {item.text}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="bg-white">
                                            <div className="d-flex flex-row fs-12">
                                                <div className="like p-2 cursor">
                                                        <span onClick={() => {
                                                            setModalShow(true);
                                                            setState(
                                                                {
                                                                    parent_id: item.id
                                                                })
                                                        }}>
                                                             <FaReply/>
                                                              <span className=" ml-2 position-relative">
                                                                add reply
                                                              </span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <ShowReply item={item}
                                               onHide={setModalShow}
                                               setState={setState}
                                    />
                                </div>
                            )
                        })
                    }
                </div>
            </div>

        </div>
        <Modal
            show={modalShow}
            labels={labels}
            onHide={setModalShow}
            state={state}
            setState={setState}
            onChange={onChange}
            setData={setData}
        />
        </body>
    )
}

export default Blog
