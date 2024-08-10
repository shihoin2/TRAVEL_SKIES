import { Nunito } from 'next/font/google'
import '@/app/global.css'
import Header from '@/components/base/Header'

const nunitoFont = Nunito({
    subsets: ['latin'],
    display: 'swap',
})

const RootLayout = ({ children }) => {
    return (
        <html lang="en" className={nunitoFont.className}>
            <body className="antialiased">
                <Header />
                {children}
                </body>
        </html>
    )
}

export const metadata = {
    title: 'Laravel',
}

export default RootLayout
