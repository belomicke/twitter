export interface IFeedData<T> {
	items: T[]
	hasNextPage: boolean
	total: number
}

export interface IFeed<T> {
	id: string
	data: IFeedData<T>
}
