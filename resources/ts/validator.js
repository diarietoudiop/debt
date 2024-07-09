class Validator {
    constructor(data) {
        this.data = data;
        this.errors = {};
    }

    validate(rules) {
        for (let name in rules) {
            if (this.data.hasOwnProperty(name)) {
                for (let rule of rules[name]) {
                    if (rule === 'required') {
                        this.required(name, this.data[name]);
                    } else if (rule.startsWith('min:')) {
                        this.min(name, this.data[name], rule);
                    } else if (rule.startsWith('max:')) {
                        this.max(name, this.data[name], rule);
                    } else if (rule === 'email') {
                        this.email(name, this.data[name]);
                    } else if (rule === 'phone') {
                        this.phone(name, this.data[name]);
                    } else if (rule === 'alpha') {
                        this.alpha(name, this.data[name]);
                    } else if (rule === 'alpha_num') {
                        this.alphaNum(name, this.data[name]);
                    } else if (rule === 'numeric') {
                        this.numeric(name, this.data[name]);
                    } else if (rule === 'url') {
                        this.url(name, this.data[name]);
                    } else if (rule === 'boolean') {
                        this.boolean(name, this.data[name]);
                    } else if (rule === 'date') {
                        this.date(name, this.data[name]);
                    } else if (rule.startsWith('same:')) {
                        this.same(name, this.data[name], rule);
                    } else if (rule.startsWith('different:')) {
                        this.different(name, this.data[name], rule);
                    } else if (rule.startsWith('in:')) {
                        this.in(name, this.data[name], rule);
                    } else if (rule.startsWith('not_in:')) {
                        this.notIn(name, this.data[name], rule);
                    } else if (rule === 'integer') {
                        this.integer(name, this.data[name]);
                    } else if (rule === 'float') {
                        this.float(name, this.data[name]);
                    } else if (rule === 'ip') {
                        this.ip(name, this.data[name]);
                    } else if (rule.startsWith('regex:')) {
                        this.regex(name, this.data[name], rule);
                    }
                }
            } else {
                this.errors[name] = [`${name} est requis.`];
            }
        }
        return Object.keys(this.errors).length > 0 ? this.errors : null;
    }

    min(name, value, rule) {
        let min = parseInt(rule.split(':')[1]);
        if (value.length < min) {
            this.errors[name] = [`${name} doit avoir au minimum ${min} caractères.`];
        }
    }

    max(name, value, rule) {
        let max = parseInt(rule.split(':')[1]);
        if (value.length > max) {
            this.errors[name] = [`${name} doit avoir au maximum ${max} caractères.`];
        }
    }

    required(name, value) {
        value = value.trim();
        if (!value) {
            this.errors[name] = [`${name} est requis.`];
        }
    }

    email(name, value) {
        if (!this.isEmail(value)) {
            this.errors[name] = [`${name} n'est pas un email valide.`];
        }
    }

    phone(name, value) {
        if (!/(70|76|77|78)[0-9]{7}/.test(value)) {
            this.errors[name] = [`${name} n'est pas un numéro de téléphone sénégalais valide.`];
        }
    }

    alpha(name, value) {
        if (!/^[a-zA-Z]+$/.test(value)) {
            this.errors[name] = [`${name} doit contenir uniquement des lettres.`];
        }
    }

    alphaNum(name, value) {
        if (!/^[a-zA-Z0-9]+$/.test(value)) {
            this.errors[name] = [`${name} doit contenir uniquement des lettres et des chiffres.`];
        }
    }

    numeric(name, value) {
        if (isNaN(value)) {
            this.errors[name] = [`${name} doit être un nombre.`];
        }
    }

    url(name, value) {
        if (!this.isUrl(value)) {
            this.errors[name] = [`${name} n'est pas une URL valide.`];
        }
    }

    boolean(name, value) {
        if (![true, false, 'true', 'false', 1, 0, '1', '0'].includes(value)) {
            this.errors[name] = [`${name} doit être un booléen.`];
        }
    }

    date(name, value) {
        if (isNaN(Date.parse(value))) {
            this.errors[name] = [`${name} n'est pas une date valide.`];
        }
    }

    same(name, value, rule) {
        let otherField = rule.split(':')[1];
        if (value !== this.data[otherField]) {
            this.errors[name] = [`${name} doit être identique à ${otherField}.`];
        }
    }

    different(name, value, rule) {
        let otherField = rule.split(':')[1];
        if (value === this.data[otherField]) {
            this.errors[name] = [`${name} doit être différent de ${otherField}.`];
        }
    }

    in(name, value, rule) {
        let allowedValues = rule.split(':')[1].split(',');
        if (!allowedValues.includes(value)) {
            this.errors[name] = [`${name} doit être l'une des valeurs suivantes : ${allowedValues.join(', ')}.`];
        }
    }

    notIn(name, value, rule) {
        let disallowedValues = rule.split(':')[1].split(',');
        if (disallowedValues.includes(value)) {
            this.errors[name] = [`${name} ne doit pas être l'une des valeurs suivantes : ${disallowedValues.join(', ')}.`];
        }
    }

    integer(name, value) {
        if (!Number.isInteger(parseInt(value))) {
            this.errors[name] = [`${name} doit être un entier.`];
        }
    }

    float(name, value) {
        if (isNaN(parseFloat(value))) {
            this.errors[name] = [`${name} doit être un nombre à virgule flottante.`];
        }
    }

    ip(name, value) {
        if (!this.isIp(value)) {
            this.errors[name] = [`${name} doit être une adresse IP valide.`];
        }
    }

    regex(name, value, rule) {
        let pattern = rule.split(':')[1];
        if (!new RegExp(pattern).test(value)) {
            this.errors[name] = [`${name} ne correspond pas au format attendu.`];
        }
    }

    isEmail(value) {
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
    }

    isUrl(value) {
        try {
            new URL(value);
            return true;
        } catch {
            return false;
        }
    }
    isUrlsIp(value) {
        return /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(value);
    }
}


