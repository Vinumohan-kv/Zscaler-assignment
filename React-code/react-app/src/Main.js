import React from 'react'
import { Routes, Route } from "react-router-dom"
import Home from './page/Home'

const Main = () => {
  return (
    <div className='bg'>
      <Routes>
        <Route path="/" element={ <Home /> } />
      </Routes>
    </div>
  )
}

export default Main
