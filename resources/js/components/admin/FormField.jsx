export default function FormField({ label, name, type = 'text', value, onChange, error, options, required = true, placeholder, ...props }) {
    if (type === 'select') {
        return (
            <div className="mb-4">
                <label htmlFor={name} className="block text-sm font-bold text-gray-700 mb-1">{label}</label>
                <select id={name} name={name} value={value} onChange={onChange} required={required} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none">
                    <option value="">Seleccione...</option>
                    {options.map(opt => (
                        <option key={opt.value} value={opt.value}>{opt.label}</option>
                    ))}
                </select>
                {error && <p className="text-red-500 text-xs mt-1">{error}</p>}
            </div>
        );
    }

    if (type === 'textarea') {
        return (
            <div className="mb-4">
                <label htmlFor={name} className="block text-sm font-bold text-gray-700 mb-1">{label}</label>
                <textarea id={name} name={name} value={value} onChange={onChange} required={required} rows={4} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" {...props}></textarea>
                {error && <p className="text-red-500 text-xs mt-1">{error}</p>}
            </div>
        );
    }

    return (
        <div className="mb-4">
            <label htmlFor={name} className="block text-sm font-bold text-gray-700 mb-1">{label}</label>
            <input id={name} name={name} type={type} value={value} onChange={onChange} required={required} placeholder={placeholder} className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sena-green focus:outline-none" {...props} />
            {error && <p className="text-red-500 text-xs mt-1">{error}</p>}
        </div>
    );
}
