import ENV from '$lib/environments/env'

export const getPing = async (event?: any): Promise<any> => {
	try {
		const response = await fetch(`${ENV.baseUrl}api/ping`)
		const data = response.json()
		return data
	} catch (error: any) {
		console.error(`${error.name}: ${error.message}`)
		return {
			status: 500
		}
	}
}
