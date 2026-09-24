import { Link } from 'react-router-dom';

export default function DataTable({ title, icon, columns, data, emptyMsg, createPath, createLabel, onDelete, actions = true }) {
    return (
        <div className="bg-white rounded-xl shadow-sm p-6 border-t-4 border-sena-green">
            <div className="flex justify-between items-center mb-4">
                <h3 className="text-lg font-bold text-sena-dark">
                    <i className={`fas ${icon} text-sena-green mr-2`}></i>{title}
                </h3>
                {createPath && (
                    <Link to={createPath} className="bg-sena-green text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                        <i className="fas fa-plus-circle mr-1"></i> {createLabel || 'Nuevo'}
                    </Link>
                )}
            </div>

            <div className="overflow-x-auto">
                <table className="w-full text-sm">
                    <thead>
                        <tr className="bg-sena-dark text-white">
                            {columns.map((col, i) => (
                                <th key={i} className={`px-4 py-3 font-semibold ${col.center ? 'text-center' : ''}`}>{col.label}</th>
                            ))}
                            {actions && <th className="px-4 py-3 text-center">Acciones</th>}
                        </tr>
                    </thead>
                    <tbody>
                        {data.length === 0 ? (
                            <tr><td colSpan={columns.length + (actions ? 1 : 0)} className="text-center text-gray-400 py-8">{emptyMsg || 'No hay registros.'}</td></tr>
                        ) : data.map((row, ri) => (
                            <tr key={ri} className="border-b hover:bg-gray-50 transition-colors">
                                {columns.map((col, ci) => (
                                    <td key={ci} className="px-4 py-3">{col.render ? col.render(row) : row[col.key]}</td>
                                ))}
                                {actions && (
                                    <td className="px-4 py-3 text-center">
                                        <div className="flex justify-center gap-2">
                                            {col.render ? null : null}
                                            {actions}
                                        </div>
                                    </td>
                                )}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}
