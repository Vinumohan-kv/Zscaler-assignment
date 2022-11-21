import React , {useState} from 'react'

const Form = () => {
  
  const [formData, setFormData] = useState({
    username: "",
    address: "",
    email: "",
    dob: false,
    password: "",
    country: "",
    gender: "female",
    agree: false,
  });

  const onSubmit = (event) => {
    event.preventDefault();
    console.log(formData)
  };



  const onChange = (event) => {
    const { name, value, type } = event.target;

    setFormData({
      ...formData,
      [name]: event.target.value,
    });
  };
 
 
  return (
    <div className="form">
     
      <form onSubmit={onSubmit}>
        {/* Labels and inputs for form data */}
        <div className="wrapper-5">
        <input onChange={onChange} className="input shape-5"
          value="" type="text" placeholder='First Name*'/>
        <input onChange={onChange} className="input shape-5-copy"
          value="" type="text" placeholder='Last Name*'/>
        <label className="label">Email</label>
        <input onChange={onChange} className="input shape-5-copy-3"
          value="" type="text" placeholder='E-mail Address*'/>
          <input onChange={onChange} className="input shape-5-copy-3-2"
          value=""  type="text" placeholder='Phone Number*'/>
         <select className="shape-5-copy-4" name="program_interest" value={formData.program_interest}
            onChange={onChange} >
            <option value="">Program of Interest*</option>
            <option value="india">India</option>
            <option value="france">France</option>
            <option value="usa">USA</option>
          </select>
          <select className="shape-5-copy-4-2" name="delivery_type" value={formData.delivery_type}
            onChange={onChange} >
            <option value="">Program Delivery Type</option>
          </select>
          <select className="shape-5-copy-4-3" name="communicaton_type" value={formData.communicaton_type}
            onChange={onChange} >
            <option value="">Preferred Communication Type</option>
          </select>
          </div>
        <button className="btn shape-5-copy-6-holder" type="submit">
          Learn More Today!
        </button>
      </form>
    </div>
  );
}

export default Form
