export default function AdminFooter() {
    return (
        <footer className="bg-sena-black text-white border-t-4 border-sena-green py-4 mt-auto">
            <div className="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-3">
                <div>
                    <h5 className="font-bold text-sena-green text-sm">Servicio Nacional de Aprendizaje - SENA</h5>
                    <p className="text-gray-400 text-xs">
                        Dirección General: Calle 57 No. 8 - 69 Bogotá D.C. - Colombia
                    </p>
                </div>
                <p className="text-gray-400 text-xs text-right">
                    &copy; {new Date().getFullYear()} SENA — Todos los derechos reservados.<br />
                    Panel Administrativo Interno
                </p>
            </div>
        </footer>
    );
}
