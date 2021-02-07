const Discord = require('discord.js');
const fetch = require('node-fetch');
const querystring = require('querystring');
require('events').EventEmitter.defaultMaxListeners = 15;


const client = new Discord.Client();
const prefix = '$';

const trim = (str, max) => (str.length > max ? `${str.slice(0, max - 3)}...` : str);

client.once('ready', () => {
	console.log('Ready!');
});




client.on('message', async message => {
    if (!message.content.startsWith(prefix) || message.author.bot) return;
    
	const args = message.content.slice(prefix.length).trim().split(/ +/);
	const command = args.shift().toLowerCase();

	if (command === 'activesubs') {

        const msg = await fetch(`https://rndm.ch/api.php?apiKey=x&action=activesubs`).then(response => response.text());
        message.channel.send("Total Active Subscribtions: " + msg);
	}
});

client.on('message', async message => {
    if (!message.content.startsWith(prefix) || message.author.bot) return;
    
	const args = message.content.slice(prefix.length).trim().split(/ +/);
	const command = args.shift().toLowerCase();

	if (command === 'freecfg') {
        if (!args.length) {
            return message.channel.send('You need to supply youre onetap userid!');
          }
        const query = querystring.stringify({ term: args.join(' ') });
        const msg = await fetch(`https://rndm.ch/api.php?apiKey=x&action=configsub&configid=2455&${query}`).then(response => response.text());
        message.channel.send(msg);
	}
});

client.on('message', async message => {
    if (!message.content.startsWith(prefix) || message.author.bot) return;
    
	const args = message.content.slice(prefix.length).trim().split(/ +/);
	const command = args.shift().toLowerCase();

	if (command === 'freescript') {
        if (!args.length) {
            return message.channel.send('You need to supply youre onetap userid!');
          }
        const query = querystring.stringify({ term: args.join(' ') });
        const msg = await fetch(`https://hostly.ch/api.php?apiKey=x&action=scriptsub&configid=2455&${query}`).then(response => response.text());
        message.channel.send(msg);
	}
});

client.login('x');
