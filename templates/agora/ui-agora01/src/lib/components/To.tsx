import { FC } from "react"
import { Link } from "react-router"
import Anchor from "../interfaces/anchor"

export const To: FC<Anchor> = ({
  path = "/",
  query = "",
  onSite = "",
  inner = ""
}) => {
  const isOnSite: boolean = path?.split("/").pop() === onSite
  const url: string = isOnSite ? "" : path

  if (!isOnSite) {
    return (
      <>
        <Link
          to={{ pathname: url, search: query }}
          className="m-1 md:m-2 lg:m-4 uppercase text-sm md:text-lg lg:text-xl"
        >
          {inner}
        </Link>
      </>
    )
  } else {
    return (
      <>
        <a
          href="#"
          aria-disabled="true"
          className="m-1 md:m-2 lg:m-4 uppercase text-sm md:text-lg lg:text-xl anchor-disabled"
        >
          {inner}
        </a>
      </>
    )
  }
}
