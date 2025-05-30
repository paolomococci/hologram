import { useState, useEffect } from 'react'
import axios from 'axios'
import ENV from '../env'

interface Response {
  data: unknown
}

interface PingTestResponse {
  status: number,
  message: string
}

const BASE_URL = ENV.baseUrl

const PingTest = () => {
  const [message, setMessage] = useState<string>('')
  const [errorMessage, setErrorMessage] = useState<string>('')
  const [loading, setLoading] = useState<boolean>(true)

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
        await axios.get('sanctum/csrf-cookie').then((res: Response) => {
          console.log(res.data)
        })
        await axios.get('api/ping').then((res: Response) => {
          console.log(res)
          setMessage((res.data as PingTestResponse).message)
          setLoading(false)
        })
      } catch (error) {
        const errorMessage = (error as Error).message
        console.log(errorMessage)
        setErrorMessage(errorMessage)
        setMessage(errorMessage)
        setLoading(false)
      }
    }
    fetchPosts()
  }, [])

  return (
    <div className="p-3 m-3">
      {loading ? (
        <p>Please wait for the data loading…</p>
      ) : errorMessage ? (
        <p>{errorMessage}</p>
      ) : (
        <div>
          <p>{message}</p>
        </div>
      )}
    </div>
  )
}

export default PingTest