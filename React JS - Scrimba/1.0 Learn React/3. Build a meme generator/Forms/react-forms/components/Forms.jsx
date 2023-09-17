import React from 'react'

export default function Form(props) {

    const [formData, setFormData] = React.useState({firstName: "", lastName: "", email: "" })


    function handleChange(ev) {

        setFormData(prevFormData => {
            return {
                ...prevFormData,
                [ev.target.name]: ev.target.value
            }
        })

        console.log(formData); 
    }


    return(
        <div>
            <p>Form</p>
            <form>
                <input 
                    type="text"
                    placeholder='First Name'
                    onChange={handleChange}
                    name='firstName' 
                />
                <input 
                    type="text"
                    placeholder='Last Name'
                    onChange={handleChange}
                    name='lastName'
                />
                <input
                type="email"
                placeholder="Email"
                onChange={handleChange}
                name="email"
                />
            </form>
        </div>
    )

}