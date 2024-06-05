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
    }

    /** collects the authors in a text string */
    authorsToString(authors) {
        let stringOfAuthors = ''
        authors.forEach(contributor => {
            console.log(`function authorToString, contributor: ${JSON.stringify(contributor)}`)
            if (!contributor.author.suspended) {
                if (!stringOfAuthors.length < 1) {
                    stringOfAuthors += ', '
                }
                stringOfAuthors += contributor.author.name + ' ' + contributor.author.surname
            }
        })
        return stringOfAuthors
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

        const printable = new jsPDF('p', 'in', 'a4')

        // set draw color
        printable.setDrawColor('#eee')

        // set line width
        printable.setLineWidth(1 / 72)

        // set the cover page
        // sets the margins of the cover page
        printable.line(this.oOffset, this.vOffset, this.oMargin, this.vOffset)
        printable.line(this.oMargin, this.vOffset, this.oMargin, this.vMargin)
        printable.line(this.oMargin, this.vMargin, this.oOffset, this.vMargin)
        printable.line(this.oOffset, this.vMargin, this.oOffset, this.vOffset)

        printable.setTextColor('#777')
        printable.setFontSize(24)
        printable.text(this.article.title.toUpperCase(), 0.787, 1.968, { maxWidth: this.maxW })

        printable.line(0.7, 3.3, 5.0, 3.3)

        // main authors
        if (this.authorsToString(mainAuthors).length > 0) {
            printable.setFontSize(14)
            printable.text('main authors:', 0.9, 4.5)
            printable.setFontSize(16)
            printable.text(this.authorsToString(mainAuthors), 0.9, 4.75, { maxWidth: this.maxW })
        }

        // contributors
        if (this.authorsToString(contributors).length > 0) {
            printable.setFontSize(14)
            printable.text('contributors:', 0.9, 5.3)
            printable.setFontSize(16)
            printable.text(this.authorsToString(contributors), 0.9, 5.55, { maxWidth: this.maxW })
        }

        printable.setTextColor('#333')
        printable.setFontSize(14)
        printable.text('subject:', 0.9, 7.1)

        printable.setFontSize(16)
        printable.text(this.article.subject, 0.9, 7.35, { maxWidth: this.maxW })

        if (this.article.summary.length > 0) {
            printable.setTextColor('#444')
            printable.setFontSize(14)
            printable.text('summary:', 0.9, 8.3)
            printable.setFontSize(16)
            printable.text(this.article.summary, 0.9, 8.55, { maxWidth: this.maxW })
        }

        // second page
        printable.addPage()

        // sets the margins of the page containing the article content
        printable.line(this.oOffset, this.vOffset, this.oMargin, this.vOffset)
        printable.line(this.oMargin, this.vOffset, this.oMargin, this.vMargin)
        printable.line(this.oMargin, this.vMargin, this.oOffset, this.vMargin)
        printable.line(this.oOffset, this.vMargin, this.oOffset, this.vOffset)

        printable.setTextColor('#222')
        printable.setFontSize(18)
        printable.text(this.article.content, 0.9, 1.968, { maxWidth: this.maxW })

        printable.save(`${fileName}.pdf`)
    }
}
