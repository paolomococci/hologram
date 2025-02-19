import { useState, useEffect } from "react"
import axios from "axios"

const CsrfCookie = () => {
  const BASE_URL = "https://api-agora01.hologram-srv.local/"
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
