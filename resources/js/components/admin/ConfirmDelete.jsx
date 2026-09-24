export default function ConfirmDelete({ open, title, message, onConfirm, onCancel }) {
    if (!open) return null;

    return (
        <>
            <div className="fixed inset-0 bg-black/50 z-50" onClick={onCancel}></div>
            <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div className="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                    <div className="text-center">
                        <div className="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i className="fas fa-trash text-red-600 text-2xl"></i>
                        </div>
                        <h3 className="text-lg font-bold text-gray-800 mb-2">{title || '¿Confirmar eliminación?'}</h3>
                        <p className="text-gray-500 text-sm mb-6">{message || 'Esta acción no se puede deshacer.'}</p>
                        <div className="flex justify-center gap-3">
                            <button onClick={onCancel} className="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors text-sm">
                                Cancelar
                            </button>
                            <button onClick={onConfirm} className="px-4 py-2 rounded-lg bg-red-600 text-white font-medium hover:bg-red-700 transition-colors text-sm">
                                <i className="fas fa-trash mr-1"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
