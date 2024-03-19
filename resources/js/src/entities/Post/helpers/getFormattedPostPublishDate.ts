import moment from 'moment'
import 'moment/dist/locale/ru'

export const getFormattedPostPublishDate = (date: string): string => {
    const m = moment(date).utc()
    const n = moment().utc()

    if (m.year() !== n.year()) {
        return m.format('yyyy-mm-DD')
    } else if (m.date() !== n.date()) {
        return m.format('DD MMM')
    } else if (m.hour() !== n.hour()) {
        return `${n.hour() - m.hour()} ч`
    } else if (m.minute() !== n.minute()) {
        return `${n.minute() - m.minute()} мин`
    } else if (m.second() !== n.second()) {
        return `${n.second() - m.second()} c`
    } else {
        return 'Сейчас'
    }
}
