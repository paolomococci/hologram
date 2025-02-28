export async function setupPing(
    uriCookie,
    uriApi,
    elementLoader,
    elementOutput
) {

    // retrieve sanctum/csrf-cookie
    const responseCookie = await fetch(uriCookie)
    if (!responseCookie.ok) {
        throw new Error(`Response status: ${responseCookie.status}`)
    } else {
        try {
            console.log('Response of csrf-cookie: ', responseCookie)
        } catch (error) {
            console.error(error)
        }
    }

    // retrieve api/ping
    let jsonResApi = null
    const responseApi = await fetch(uriApi)
    if (!responseApi.ok) {
        throw new Error(`Response status: ${responseApi.status}`)
    } else {
        try {
            jsonResApi = await responseApi.json()
            console.log(jsonResApi)
        } catch (error) {
            console.error(error)
        }
    }

    elementLoader.remove()
    elementOutput.innerHTML = (jsonResApi === null) ? 'No data to return!' : `${jsonResApi.message}`
}
