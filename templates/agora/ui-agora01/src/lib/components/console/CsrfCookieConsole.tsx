import { useGetCsrfCookieQuery } from "../../services/csrf-cookie-service"

export const CsrfCookieConsole = () => {
  const { data, error, isLoading } = useGetCsrfCookieQuery()

  console.log("Is Loading: ", isLoading)
  console.log("Error: ", error)
  console.dir("Data: ", data)

  return <>{/* TODO */}</>
}
