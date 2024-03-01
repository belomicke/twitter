export interface IFeedData<T> {
    items: T[]
    total: number
}

export interface IFeed<T> {
    id: string
    data: IFeedData<T>
}
