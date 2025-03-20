import ENV from '$lib/environments/env'

export const getCsrfCookie = async (event?: any): Promise<any> => {
	try {
		const response = await fetch(`${ENV.baseUrl}sanctum/csrf-cookie`)
		return response.status
	} catch (error: any) {
		console.error(`${error.name}: ${error.message}`)
		return {
			status: 500
		}
	}
}
