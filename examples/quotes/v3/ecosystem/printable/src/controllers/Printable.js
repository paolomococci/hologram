import { jsPDF } from 'jspdf'

export const Printable = class {

    constructor(
        article,
        oOffset = 0.635,
        oMargin = 7.0,
        vOffset = 0.845,
        vMargin = 10.0,
        maxW = 6.0
    ) {
        this.article = article
        this.oOffset = oOffset
        this.oMargin = oMargin
        this.vOffset = vOffset
        this.vMargin = vMargin
        this.maxW = maxW
        this.printable = new jsPDF('p', 'in', 'a4')
    }

    /** generate the article in PDF format from JSON data */
    generatePdf() {
        console.log(`Click on article: ${this.article.title}`)

        // prepare the name of the file to download
        const fileName = this.article.title.replace(/([:,\s])+/g, '_')

        /**  */
        let mainAuthors = new Array()
        /**  */
        let contributors = new Array()
        this.article.contributors.forEach(contributor => {
            if (contributor.isMain) {
                mainAuthors.push(contributor)
            } else {
                contributors.push(contributor)
            }
        })

        // set draw color
        this.printable.setDrawColor('#eee')

        // set line width
        this.printable.setLineWidth(1 / 72)

        // set the cover page
        // sets the margins of the cover page
        this.printable.line(this.oOffset, this.vOffset, this.oMargin, this.vOffset)
        this.printable.line(this.oMargin, this.vOffset, this.oMargin, this.vMargin)
        this.printable.line(this.oMargin, this.vMargin, this.oOffset, this.vMargin)
        this.printable.line(this.oOffset, this.vMargin, this.oOffset, this.vOffset)

        this.printable.setTextColor('#777')
        this.printable.setFontSize(24)
        this.printable.text(this.article.title.toUpperCase(), 0.787, 1.968, { maxWidth: this.maxW })

        this.printable.line(0.7, 3.3, 5.0, 3.3)

        // main authors
        if (this.authorsToString(mainAuthors).length > 0) {
            this.printable.setFontSize(14)
            this.printable.text('main authors:', 0.9, 4.5)
            this.printable.setFontSize(16)
            this.printable.text(this.authorsToString(mainAuthors), 0.9, 4.75, { maxWidth: this.maxW })
        }

        // contributors
        if (this.authorsToString(contributors).length > 0) {
            this.printable.setFontSize(14)
            this.printable.text('contributors:', 0.9, 5.3)
            this.printable.setFontSize(16)
            this.printable.text(this.authorsToString(contributors), 0.9, 5.55, { maxWidth: this.maxW })
        }

        this.printable.setTextColor('#333')
        this.printable.setFontSize(14)
        this.printable.text('subject:', 0.9, 7.1)

        this.printable.setFontSize(16)
        this.printable.text(this.article.subject, 0.9, 7.35, { maxWidth: this.maxW })

        if (this.article.summary.length > 0) {
            this.printable.setTextColor('#444')
            this.printable.setFontSize(14)
            this.printable.text('summary:', 0.9, 8.3)
            this.printable.setFontSize(16)
            this.printable.text(this.article.summary, 0.9, 8.55, { maxWidth: this.maxW })
        }


        const lines = this.splitToLines(this.article.content)
        const pages = this.preparePages(lines)

        // all other pages
        pages.forEach(page => {
            this.printable.addPage()
            this.printable.setTextColor('#222')
            this.printable.line(this.oOffset, this.vOffset, this.oMargin, this.vOffset)
            this.printable.line(this.oMargin, this.vOffset, this.oMargin, this.vMargin)
            this.printable.line(this.oMargin, this.vMargin, this.oOffset, this.vMargin)
            this.printable.line(this.oOffset, this.vMargin, this.oOffset, this.vOffset)
            this.printable.setFontSize(18)
            this.printable.text(page, 0.9, 1.218, { maxWidth: this.maxW })
        })

        // actual generation of the newly created document
        this.printable.save(`${fileName}.pdf`)
    }

    /** collects the authors in a text string */
    authorsToString(authors) {
        let stringOfAuthors = ''
        authors.forEach(contributor => {
            if (!contributor.author.suspended) {
                if (!stringOfAuthors.length < 1) {
                    stringOfAuthors += ', '
                }
                stringOfAuthors += contributor.author.name + ' ' + contributor.author.surname
            }
        })
        return stringOfAuthors
    }

    /** divides the article content into multiple lines */
    splitToLines(content) {
        const lines = []
        const words = content.split(/[\s]+/g)
        let line = ''
        words.forEach(word => {
            line += word + ' '
            if (line.length > 48) {
                let overflow = line.split(' ').pop()
                lines.push(line)
                line = overflow
            }
        })
        console.log(lines)
        return lines
    }

    /** prepare the pagination of the article content */
    preparePages(lines) {
        const pages = []
        let page = ''
        let index = 0
        lines.forEach(line => {
            page += line
            index++
            if (!(index % 30)) {
                pages.push(page)
                page = ''
            }
        })
        pages.push(page)
        console.log(pages.length)
        return pages
    }
}
