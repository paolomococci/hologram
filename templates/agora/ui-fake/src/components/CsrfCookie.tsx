import { useState, useEffect } from "react"
import axios from "axios"
import ENV from '../env'

const CsrfCookie = () => {
  const BASE_URL = ENV.baseUrl
  const [message, setMessage] = useState("")

  axios.create({
    httpsAgent: {
      rejectUnauthorized: false,
      secureOptions: 0x2 | 0x4,
    },
  })
  axios.defaults.withCredentials = true
  axios.defaults.withXSRFToken = true
  axios.defaults.baseURL = BASE_URL

  useEffect(() => {
    const fetchPosts = async () => {
      try {
        await axios.get("sanctum/csrf-cookie").then((res) => {
          console.log(res.data)
          setMessage(res.data)
        });
      } catch (error) {
        console.log(error)
      }
    };
    fetchPosts()
  }, [])

  return (
    <>
      <p>{message}</p>
    </>
  )
}

export default CsrfCookie
