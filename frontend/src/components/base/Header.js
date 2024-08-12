import Logo from '@/components/base/Logo'
import Chevrons from '@/components/base/Chevrons'

const Header = ({ active = false, children, ...props }) => {
    return (
        <>
            <div className="bg-white  border-b border-gray-200">
                <div className="mx-auto max-w-screen-2xl px-4 md:px-8">
                    <header className="flex items-center justify-between py-4 md:py-8">
                        {/* logo - start */}
                        <a
                            href="/"
                            className="inline-flex items-center gap-2.5 text-2xl font-bold text-black md:text-3xl"
                            aria-label="logo">
                            <img
                                className="w-10 h-auto"
                                src="/Logo_rem.png"
                                alt="Logo"
                            />
                            TRAVEL SKIES
                        </a>
                        {/* logo - end */}
                        {/* nav - start */}
                    </header>
                </div>
            </div>
            <Chevrons />
        </>
    )
}
export default Header
